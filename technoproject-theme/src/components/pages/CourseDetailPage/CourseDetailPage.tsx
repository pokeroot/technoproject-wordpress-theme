// technoproject-theme/src/components/pages/CourseDetailPage/CourseDetailPage.tsx
import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { Course } from '../../../types/course.types'; // Adjust path if needed
import styles from './CourseDetailPage.module.scss';

const CourseDetailPage: React.FC = () => {
  const { courseId } = useParams<{ courseId: string }>();
  const [course, setCourse] = useState<Course | null>(null);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    if (!courseId) {
      setError('No se proporcionó ID de curso.');
      setIsLoading(false);
      return;
    }

    const fetchCourseDetail = async () => {
      setIsLoading(true);
      setError(null);
      try {
        // Proxy will redirect this to https://technoproject.com.co/wp-json/technoproject/v1/courses/{courseId}
        const response = await fetch(`/wp-json/technoproject/v1/courses/${courseId}`);
        if (!response.ok) {
          const errorData = await response.json().catch(() => ({ message: 'Error fetching course details' }));
          throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }
        const data: Course = await response.json();
        setCourse(data);
      } catch (err) {
        if (err instanceof Error) {
          setError(err.message);
        } else {
          setError('An unknown error occurred while fetching course details.');
        }
        console.error(`Failed to fetch course details for ID ${courseId}:`, err);
      } finally {
        setIsLoading(false);
      }
    };

    fetchCourseDetail();
  }, [courseId]); // Re-run effect if courseId changes

  if (isLoading) {
    return <div className={styles.loadingState}>Cargando detalles del curso...</div>;
  }

  if (error) {
    return <div className={styles.errorState}>Error al cargar el curso: {error} <Link to="/cursos">Volver a la lista</Link></div>;
  }

  if (!course) {
    return <div className={styles.emptyState}>Curso no encontrado. <Link to="/cursos">Volver a la lista</Link></div>;
  }

  // Render course details
  return (
    <article className={styles.courseDetailPage}>
      {course.featured_image_url && (
        <img src={course.featured_image_url} alt={`Imagen de ${course.title.rendered}`} className={styles.featuredImage} />
      )}
      <header className={styles.header}>
        <h1>{course.title.rendered}</h1>
        <div className={styles.meta}>
          {course.level && <span className={`${styles.tag} ${styles.level}`}>{course.level}</span>}
          {course.format && <span className={`${styles.tag} ${styles.format}`}>{course.format}</span>}
        </div>
      </header>

      {course.short_description && (
        <p className={styles.shortDescription}>{course.short_description}</p>
      )}

      {course.content?.rendered && (
        <section className={styles.contentSection} dangerouslySetInnerHTML={{ __html: course.content.rendered }} />
      )}

      {/* TODO: Display other course details like:
          - Instructor
          - Sessions
          - Materials
          - Requirements
          - Objectives
          - Certification info
          - Price, duration, capacity, enrolled, etc.
          - Course categories and skill tags (if not already part of meta)
      */}

      <div className={styles.actions}>
        <Link to="/cursos" className={styles.backLink}>&larr; Volver a todos los cursos</Link>
        {/* Add other actions like "Enroll Now" button later */}
      </div>
    </article>
  );
};

export default CourseDetailPage;
