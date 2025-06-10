// technoproject-theme/src/types/course.types.ts

// Assuming Instructor, Session, Material, Certification etc. will be defined later
// or imported if already defined.
// For now, using 'any' or basic types as placeholders for those complex nested objects
// that were in the original very detailed Course interface from the document,
// but are not yet in our simplified API response.

// From the API response structure of WP REST API for taxonomies
export interface TaxonomyTerm {
  id: number;
  name: string;
  slug: string;
  // link?: string; // WP REST API often includes a link
  // description?: string;
  // count?: number;
}

// WP REST API often returns title, content, excerpt as objects with a 'rendered' field
export interface WPRenderedString {
  rendered: string;
  raw?: string; // raw is often available if context=edit
}

// Based on the current API (Technoproject_Courses_Controller)
// and aiming for some fields from the original Course interface (section 3.2 of doc)
export interface Course {
  id: number; // From WP_Post ID
  title: WPRenderedString; // e.g., { rendered: "Course Title" }
  slug?: string; // From WP_Post post_name
  date?: string; // ISO 8601 date string
  modified?: string; // ISO 8601 date string
  status?: string; // e.g., 'publish', 'draft'
  content?: WPRenderedString; // Full course description
  excerpt?: WPRenderedString; // Short summary

  // Custom fields we added
  short_description?: string; // Our custom meta field
  level?: string; // Our custom meta field (e.g., 'beginner', 'intermediate')
  format?: string; // Our custom meta field (e.g., 'online', 'hybrid')

  // Taxonomies we added
  course_categories?: TaxonomyTerm[];
  skill_tags?: TaxonomyTerm[];

  // Fields from the original comprehensive 'Course' interface (section 3.2)
  // to be added as the API and CPT evolve.
  // For now, these are optional or commented out if not yet in API.
  // instructor?: any; // TODO: Define Instructor type and add to API
  // course_format_enum?: CourseFormat; // TODO: Define and map from 'format' string
  // duration?: CourseDuration; // TODO: Define and add as meta
  // course_level_enum?: CourseLevel; // TODO: Define and map from 'level' string
  // price?: CoursePrice; // TODO: Define and add as meta
  // rating?: CourseRating; // TODO: Define and add as meta
  thumbnail_url?: string; // TODO: Get from featured media
  // gallery?: string[]; // TODO: Add as meta or use a gallery plugin
  // tags?: string[]; // Covered by skill_tags or could be separate post_tag
  // categories?: Category[]; // Covered by course_categories
  // startDate?: Date; // TODO: Add as meta
  // endDate?: Date; // TODO: Add as meta
  // capacity?: number; // TODO: Add as meta
  // enrolled?: number; // TODO: Add as meta or calculate
  // sessions?: any[]; // TODO: Define Session type and link CPTs/API
  // materials?: any[]; // TODO: Define Material type
  // requirements?: string[]; // TODO: Add as meta
  // objectives?: string[]; // TODO: Add as meta
  // certification?: any; // TODO: Define Certification type
  // createdAt?: Date; // From WP_Post post_date
  // updatedAt?: Date; // From WP_Post post_modified

  // Link to the course (permalink)
  link?: string; // Often included by WP REST API

  // Placeholder for featured image if API provides it
  _embedded?: { // WP REST API often uses _embedded for featured images, author etc.
     'wp:featuredmedia'?: [{
         source_url: string;
         alt_text?: string;
         // ... other media details
     }];
     author?: [{
         id: number;
         name: string;
         // ... other author details
     }];
     'wp:term'?: TaxonomyTerm[][]; // Holds all taxonomy terms if requested with _embed
  };
}

// Enums from original document (section 3.2), can be used for consistency
// if we ensure the string values from meta fields map to these.
export enum CourseFormat {
    HYBRID = 'hybrid',
    ONLINE = 'online',
    PRESENCIAL = 'presencial',
}

export enum CourseLevel {
    BEGINNER = 'beginner',
    INTERMEDIATE = 'intermediate',
    ADVANCED = 'advanced',
}

// Example for a more complex field like Price (from original doc)
// export interface CoursePrice {
//   amount: number;
//   currency: string; // e.g., 'USD', 'EUR'
//   payment_plans?: string[]; // e.g., ['full', 'installments']
// }
