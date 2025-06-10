// technoproject-theme/src/components/molecules/CourseCard/CourseCard.tsx
import React from 'react';
import { Course } from '../../../types/course.types'; // Adjust path if your tsconfig paths are not picked up by the subtask runner
import Button from '../../atoms/Button'; // Assuming Button is correctly exported from atoms
import styles from './CourseCard.module.scss';

export interface CourseCardProps {
  course: Course;
  className?: string;
}

const CourseCard: React.FC<CourseCardProps> = ({ course, className }) => {
  // Placeholder for featured image - to be added when API provides it
  // const imageUrl = course._embedded?.['wp:featuredmedia']?.[0]?.source_url || 'https://via.placeholder.com/300x200?text=Course+Image';
  const imageUrl = `https://via.placeholder.com/300x200?text=${encodeURIComponent(course.title.rendered)}`;


  return (
    <article className={`${styles.courseCard} ${className || ''}`}>
      <div className={styles.imageWrapper}>
        <img src={imageUrl} alt={`Imagen del curso ${course.title.rendered}`} className={styles.image} />
      </div>
      <div className={styles.content}>
        <h3 className={styles.title}>{course.title.rendered}</h3>
        {course.short_description && (
          <p className={styles.shortDescription}>{course.short_description}</p>
        )}
        <div className={styles.meta}>
          {course.level && (
            <span className={`${styles.tag} ${styles.level}`}>{course.level}</span>
          )}
          {course.format && (
            <span className={`${styles.tag} ${styles.format}`}>{course.format}</span>
          )}
        </div>
        <div className={styles.actions}>
          <Button
             href={course.link || '#'} // Use actual course link when available
             variant="primary"
             size="small"
          >
            Ver Detalles
          </Button>
        </div>
      </div>
    </article>
  );
};

export default CourseCard;
