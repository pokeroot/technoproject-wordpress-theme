// technoproject-theme/src/components/molecules/CourseCard/CourseCard.tsx
import React from 'react';
import { Link } from 'react-router-dom'; // Import Link
import { Course } from '../../../types/course.types';
import Button from '../../atoms/Button';
import styles from './CourseCard.module.scss';

export interface CourseCardProps {
  course: Course;
  className?: string;
}

const CourseCard: React.FC<CourseCardProps> = ({ course, className }) => {
  const imageUrl = course.featured_image_url || `https://via.placeholder.com/300x200?text=${encodeURIComponent(course.title.rendered)}`;
  // Ensure course.id is available. It should be from our API.
  const detailUrl = course.id ? `/cursos/${course.id}` : '#'; // Fallback if id is somehow missing

  return (
    <article className={`${styles.courseCard} ${className || ''}`}>
      <div className={styles.imageWrapper}>
        <img src={imageUrl} alt={`Imagen del curso ${course.title.rendered}`} className={styles.image} />
      </div>
      <div className={styles.content}>
        <h3 className={styles.title}>
          {/* Optionally, make the title a link too */}
          {/* <Link to={detailUrl} className={styles.titleLink}>{course.title.rendered}</Link> */}
          {course.title.rendered}
        </h3>
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
          <Link to={detailUrl} className={styles.buttonLinkWrapper}> {/* Wrapper for styling if Button itself is not a Link */}
            <Button
               variant="primary"
               size="small"
               // No href or 'to' here, Link handles navigation
            >
              Ver Detalles
            </Button>
          </Link>
        </div>
      </div>
    </article>
  );
};

export default CourseCard;
