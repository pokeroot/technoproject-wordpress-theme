// technoproject-theme/src/components/organisms/CourseList/CourseList.tsx
import React, { useEffect, useState } from 'react';
import { Course } from '../../../types/course.types'; // Adjust path if needed
import CourseCard from '../../molecules/CourseCard'; // Adjust path if needed
import { Spinner } from '../../atoms/Spinner'; // Adjust path as needed
import styles from './CourseList.module.scss';

export interface CourseListProps {
  className?: string;
  // Future props: filters, pagination settings, etc.
}

const CourseList: React.FC<CourseListProps> = ({ className }) => {
  const [courses, setCourses] = useState<Course[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchCourses = async () => {
      setIsLoading(true);
      setError(null);
      try {
        // IMPORTANT: The base URL for the WordPress REST API.
        // In a real app, this would come from a config or environment variable.
        // For SiteGround, it might be your site URL.
        // If WordPress and the React dev server are on different ports/domains,
        // ensure CORS is handled on the WordPress side or use a proxy in webpack.dev.js.
        const response = await fetch('/wp-json/technoproject/v1/courses');

        if (!response.ok) {
          const errorData = await response.json().catch(() => ({ message: 'Error fetching courses' }));
          throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }
        const data: Course[] = await response.json();
        setCourses(data);
      } catch (err) {
        if (err instanceof Error) {
          setError(err.message);
        } else {
          setError('An unknown error occurred.');
        }
        console.error("Failed to fetch courses:", err);
      } finally {
        setIsLoading(false);
      }
    };

    fetchCourses();
  }, []); // Empty dependency array means this effect runs once on mount

  if (isLoading) {
    return (
      <div className={styles.loadingState}>
        <Spinner size="large" color="primary" />
        {/* Optional: Keep text or remove it if spinner is clear enough */}
        {/* <p>Cargando cursos...</p> */}
      </div>
    );
  }

  if (error) {
    return <div className={styles.errorState}>Error al cargar cursos: {error}</div>;
  }

  if (courses.length === 0) {
    return <div className={styles.emptyState}>No hay cursos disponibles en este momento.</div>;
  }

  return (
    <section className={`${styles.courseList} ${className || ''}`}>
      {courses.map((course) => (
        <CourseCard key={course.id} course={course} />
      ))}
    </section>
  );
};

export default CourseList;
