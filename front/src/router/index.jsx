import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { Suspense, lazy } from "react";
import { useAuth } from "../hooks/useAuth";
import { ROLE_HOME } from "../utils/roles";
import { PrivateRoute } from "../components/shared/PrivateRoute";
import { RoleGuard } from "../components/shared/RoleGuard";
import { AppLayout } from "../components/layout/AppLayout";
import Loading from "../components/shared/Loading";

// Lazy-loaded para cargar solo cuando se necesiten (y permitir prefetching desde el sidebar)
const LoginPage = lazy(() => import("../pages/auth/LoginPage").then(m => ({ default: m.LoginPage })));
const AdminDashboard = lazy(() => import("../pages/admin/AdminDashboard").then(m => ({ default: m.AdminDashboard })));
const CoursesPage = lazy(() => import("../pages/admin/CoursesPage").then(m => ({ default: m.CoursesPage })));
const CourseFormPage = lazy(() => import("../pages/admin/CourseFormPage").then(m => ({ default: m.CourseFormPage })));
const EnrollmentsPage = lazy(() => import("../pages/admin/EnrollmentsPage").then(m => ({ default: m.EnrollmentsPage })));
const UsersPage = lazy(() => import("../pages/admin/UsersPage").then(m => ({ default: m.UsersPage })));
const UserFormPage = lazy(() => import("../pages/admin/UserFormPage").then(m => ({ default: m.UserFormPage })));
const TeacherDashboard = lazy(() => import("../pages/teacher/TeacherDashboard").then(m => ({ default: m.TeacherDashboard })));
const TeacherCoursePage = lazy(() => import("../pages/teacher/TeacherCoursePage").then(m => ({ default: m.TeacherCoursePage })));
const StudentDashboard = lazy(() => import("../pages/student/StudentDashboard").then(m => ({ default: m.StudentDashboard })));
const StudentCoursePage = lazy(() => import("../pages/student/StudentCoursePage").then(m => ({ default: m.StudentCoursePage })));

function RootRedirect() {
  const { user, isLoading } = useAuth();
  if (isLoading) return null;
  if (!user) return <Navigate to="/login" replace />;
  return <Navigate to={ROLE_HOME[user.role]} replace />;
}

export function AppRouter() {
  return (
    <BrowserRouter>
      <Suspense fallback={<Loading />}>
        <Routes>
          <Route path="/login" element={<LoginPage />} />
          <Route path="/" element={<RootRedirect />} />

          {/* protegidas */}
          <Route
            element={
              <PrivateRoute>
                <AppLayout />
              </PrivateRoute>
            }
          >
            <Route
              path="/admin"
              element={
                <RoleGuard role="admin">
                  <AdminDashboard />
                </RoleGuard>
              }
            />
          <Route
            path="/admin/courses"
            element={
              <RoleGuard role="admin">
                <CoursesPage />
              </RoleGuard>
            }
          />
          <Route
            path="/admin/courses/new"
            element={
              <RoleGuard role="admin">
                <CourseFormPage />
              </RoleGuard>
            }
          />
          <Route
            path="/admin/courses/:id/edit"
            element={
              <RoleGuard role="admin">
                <CourseFormPage />
              </RoleGuard>
            }
          />
          <Route
            path="/admin/courses/:id/enrollments"
            element={
              <RoleGuard role="admin">
                <EnrollmentsPage />
              </RoleGuard>
            }
          />
          <Route
            path="/admin/users"
            element={
              <RoleGuard role="admin">
                <UsersPage />
              </RoleGuard>
            }
          />
          <Route
            path="/admin/users/new"
            element={
              <RoleGuard role="admin">
                <UserFormPage />
              </RoleGuard>
            }
          />
          <Route
            path="/admin/users/:id/edit"
            element={
              <RoleGuard role="admin">
                <UserFormPage />
              </RoleGuard>
            }
          />

          <Route
            path="/teacher"
            element={
              <RoleGuard role="teacher">
                <TeacherDashboard />
              </RoleGuard>
            }
          />
          <Route
            path="/teacher/courses/:id"
            element={
              <RoleGuard role="teacher">
                <TeacherCoursePage />
              </RoleGuard>
            }
          />

          <Route
            path="/student"
            element={
              <RoleGuard role="student">
                <StudentDashboard />
              </RoleGuard>
            }
          />
          <Route
            path="/student/courses/:id"
            element={
              <RoleGuard role="student">
                <StudentCoursePage />
              </RoleGuard>
            }
          />
        </Route>

        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </Suspense>
    </BrowserRouter>
  );

}
