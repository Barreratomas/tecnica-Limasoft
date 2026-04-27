import instance from './axios'

export const coursesApi = {
  getCourses: () =>
    instance.get('/courses'),

  getCourse: (id) =>
    instance.get(`/courses/${id}`),

  createCourse: (data) =>
    instance.post('/courses', data),

  updateCourse: (id, data) =>
    instance.put(`/courses/${id}`, data),

  deleteCourse: (id) =>
    instance.delete(`/courses/${id}`),

  getCourseStudents: (courseId) =>
    instance.get(`/courses/${courseId}/students`),

  enrollStudent: (courseId, studentId) =>
    instance.post(`/courses/${courseId}/enroll`, { student_id: studentId }),

  unenrollStudent: (enrollmentId) =>
    instance.delete(`/enrollments/${enrollmentId}`),
}