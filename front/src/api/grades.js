import instance from './axios'

export const gradesApi = {
  getGrade: (enrollmentId) =>
    instance.get(`/enrollments/${enrollmentId}/grade`),

  updateGrade: (enrollmentId, data) =>
    instance.put(`/enrollments/${enrollmentId}/grade`, data),
}