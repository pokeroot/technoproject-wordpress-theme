// technoproject-theme/src/types/user.types.ts

// Forward declaration or import of other types if they were in separate files
// For now, defining related enums/types directly here for simplicity.
// These would ideally be co-located or imported if they are shared across more type definitions.

export enum UserRole {
    STUDENT = 'student',
    INSTRUCTOR = 'instructor',
    ADMINISTRATOR = 'administrator',
    COURSE_MANAGER = 'course_manager', // Added based on section 4.3
    // Add other roles as necessary
}

export enum UserStatus {
    ACTIVE = 'active',
    INACTIVE = 'inactive',
    PENDING = 'pending',
    SUSPENDED = 'suspended',
}

// Assuming Course, Certificate etc. will be defined in their own type files later
// For now, using 'any' or basic types as placeholders if not central to User structure itself.
// Ideally: import { Course } from './course.types';
// import { Certificate } from './certificate.types'; (Placeholder for now)

interface Course { // Basic placeholder
  id: string;
  title: string;
  // ... other properties
}

interface Certificate { // Basic placeholder
  id: string;
  courseName: string;
  dateIssued: Date;
  // ... other properties
}

interface Enrollment { // Basic placeholder
    courseId: string;
    enrollmentDate: Date;
    status: string; // e.g., 'active', 'completed', 'dropped'
}

export interface UserPreferences {
    language?: string;
    theme?: 'light' | 'dark';
    notifications?: {
        email?: boolean;
        sms?: boolean;
        push?: boolean;
    };
    // Add other preference fields
}

export interface UserProfile {
    bio?: string;
    website?: string;
    linkedin?: string;
    twitter?: string;
    github?: string;
    // Add other profile fields
}

// Based on section 3.2
export interface User {
    id: string;
    email: string;
    username: string;
    firstName: string;
    lastName: string;
    avatar: string; // URL to avatar image
    role: UserRole;
    status: UserStatus;
    preferences: UserPreferences;
    profile: UserProfile;
    enrollments: Enrollment[]; // Simplified for now
    certificates: Certificate[]; // Simplified for now
    createdAt: Date;
    lastLoginAt?: Date; // Optional as it might not be available immediately
}

// Student-specific types, based on section 3.2
export interface AcademicInfo {
    studentId?: string;
    university?: string;
    faculty?: string;
    major?: string;
    graduationYear?: number;
}

export interface LearningPath { // Placeholder
    id: string;
    name: string;
    courses: string[]; // Array of course IDs
    progress?: number; // Overall progress percentage
}

export interface CourseProgress { // Placeholder, more detail in Course types later
    courseId: string;
    completedLessons: number;
    totalLessons: number;
    percentage: number;
    lastAccessed: Date;
}

export interface Achievement { // Placeholder
    id: string;
    name: string;
    description: string;
    dateEarned: Date;
    icon?: string;
}

export interface Student extends User {
    role: UserRole.STUDENT; // Discriminator
    academicInfo?: AcademicInfo; // Optional as per diagram structure
    learningPath?: LearningPath; // Optional
    progress?: CourseProgress[]; // Optional
    achievements?: Achievement[]; // Optional
    wishlist?: Course[]; // Optional
}

// Instructor-specific types, based on section 3.2
export interface InstructorRating { // Placeholder
    average: number;
    count: number;
}

export interface Qualification { // Placeholder
    degree: string;
    institution: string;
    year: number;
    documentUrl?: string;
}

export interface SocialLinks { // Placeholder
    linkedin?: string;
    twitter?: string;
    website?: string;
    // other social platforms
}

export interface Instructor extends User {
    role: UserRole.INSTRUCTOR; // Discriminator
    bio: string;
    expertise: string[]; // Array of expertise areas/tags
    courses: Course[]; // Courses taught by this instructor (could be IDs or full objects)
    rating?: InstructorRating; // Optional
    qualifications?: Qualification[]; // Optional
    socialLinks?: SocialLinks; // Optional
}
