import { Outlet } from 'react-router-dom'
import { Navbar } from './Navbar'
import { Sidebar } from './Sidebar'
import './layout.css'
import { useState } from 'react'

export function AppLayout() {
  const [sidebarOpen, setSidebarOpen] = useState(false)

  return (
    <div className="app-shell">
      <Navbar onToggleSidebar={() => setSidebarOpen(v => !v)} />
      <div className="app-main">
        <Sidebar open={sidebarOpen} onClose={() => setSidebarOpen(false)} />
        {sidebarOpen && <div className="sidebar-overlay" onClick={() => setSidebarOpen(false)} />}
        <main className="app-content">
          <Outlet />
        </main>
      </div>
    </div>
  )
}