<?php
error_reporting(0);
date_default_timezone_set("asia/jakarta");
session_start();

if($_SESSION['isLogin']==false or $_SESSION['level']!="admin"){
  header("location:../logout.php");
}
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistem Informasi Akademik</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE 4 | Theme Customize" />
    <meta name="author" content="ColorlibHQ" /> 
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="../assets/css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../assets/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-secondary">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="./?p=dashboard" class="nav-link">Home</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
            <!--end::Navbar Search-->
            <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-chat-text"></i>
                <span class="navbar-badge badge text-bg-danger">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="../assets/img/user1-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-end fs-7 text-danger"
                          ><i class="bi bi-star-fill"></i
                        ></span>
                      </h3>
                      <p class="fs-7">Call me whenever you can...</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="../assets/img/user8-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        John Pierce
                        <span class="float-end fs-7 text-secondary">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">I got your message bro</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="../assets/img/user3-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Nora Silvester
                        <span class="float-end fs-7 text-warning">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">The subject goes here</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <!--end::Messages Dropdown Menu-->
            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i>
                <span class="navbar-badge badge text-bg-warning">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-envelope me-2"></i> 4 new messages
                  <span class="float-end text-secondary fs-7">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-people-fill me-2"></i> 8 friend requests
                  <span class="float-end text-secondary fs-7">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                  <span class="float-end text-secondary fs-7">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
              </div>
            </li>
            <!--end::Notifications Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="../assets/img/user2-160x160.jpg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline">Administrator</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="../assets/img/user2-160x160.jpg"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    Si Mimin
                  </p>
                </li>
                <!--end::User Image-->

                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="./?p=gantiPW" class="btn btn-default btn-flat">Ganti Password</a>
                  <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-secondary-subtle shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./?p=dashboard.php" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="../assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">SI-MBG</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-header">Menu Utama</li>

              <li class="nav-item">
                <a href="./?p=sppg" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Kelola SPPG</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./?p=gantiPW" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Ganti Password</p>
                </a>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <?php require_once('route.php'); ?>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2025&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">SIMBG</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../assets/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const appSidebar = document.querySelector('.app-sidebar');
        const sidebarColorModes = document.querySelector('#sidebar-color-modes');
        const sidebarColor = document.querySelector('#sidebar-color');
        const sidebarColorCode = document.querySelector('#sidebar-color-code');

        const themeBg = [
          'bg-primary',
          'bg-primary-subtle',
          'bg-secondary',
          'bg-secondary-subtle',
          'bg-success',
          'bg-success-subtle',
          'bg-danger',
          'bg-danger-subtle',
          'bg-warning',
          'bg-warning-subtle',
          'bg-info',
          'bg-info-subtle',
          'bg-light',
          'bg-light-subtle',
          'bg-dark',
          'bg-dark-subtle',
          'bg-body-secondary',
          'bg-body-tertiary',
          'bg-body',
          'bg-black',
          'bg-white',
          'bg-transparent',
        ];

        // loop through each option themeBg array
        document.querySelector('#sidebar-color').innerHTML = themeBg.map((bg) => {
          // return option element with value and text
          return `<option value="${bg}" class="text-${bg}">${bg}</option>`;
        });

        let sidebarColorMode = '';
        let sidebarBg = '';

        function updateSidebar() {
          appSidebar.setAttribute('data-bs-theme', sidebarColorMode);

          sidebarColorCode.innerHTML = `<pre><code class="language-html">&lt;aside class="app-sidebar ${sidebarBg}" data-bs-theme="${sidebarColorMode}"&gt;...&lt;/aside&gt;</code></pre>`;
        }

        sidebarColorModes.addEventListener('input', (event) => {
          sidebarColorMode = event.target.value;
          updateSidebar();
        });

        sidebarColor.addEventListener('input', (event) => {
          sidebarBg = event.target.value;

          themeBg.forEach((className) => {
            appSidebar.classList.remove(className);
          });

          if (themeBg.includes(sidebarBg)) {
            appSidebar.classList.add(sidebarBg);
          }

          updateSidebar();
        });
      });

      document.addEventListener('DOMContentLoaded', () => {
        const appNavbar = document.querySelector('.app-header');
        const navbarColorModes = document.querySelector('#navbar-color-modes');
        const navbarColor = document.querySelector('#navbar-color');
        const navbarColorCode = document.querySelector('#navbar-color-code');

        const themeBg = [
          'bg-primary',
          'bg-primary-subtle',
          'bg-secondary',
          'bg-secondary-subtle',
          'bg-success',
          'bg-success-subtle',
          'bg-danger',
          'bg-danger-subtle',
          'bg-warning',
          'bg-warning-subtle',
          'bg-info',
          'bg-info-subtle',
          'bg-light',
          'bg-light-subtle',
          'bg-dark',
          'bg-dark-subtle',
          'bg-body-secondary',
          'bg-body-tertiary',
          'bg-body',
          'bg-black',
          'bg-white',
          'bg-transparent',
        ];

        // loop through each option themeBg array
        document.querySelector('#navbar-color').innerHTML = themeBg.map((bg) => {
          // return option element with value and text
          return `<option value="${bg}" class="text-${bg}">${bg}</option>`;
        });

        let navbarColorMode = '';
        let navbarBg = '';

        function updateNavbar() {
          appNavbar.setAttribute('data-bs-theme', navbarColorMode);
          navbarColorCode.innerHTML = `<pre><code class="language-html">&lt;nav class="app-header navbar navbar-expand ${navbarBg}" data-bs-theme="${navbarColorMode}"&gt;...&lt;/nav&gt;</code></pre>`;
        }

        navbarColorModes.addEventListener('input', (event) => {
          navbarColorMode = event.target.value;
          updateNavbar();
        });

        navbarColor.addEventListener('input', (event) => {
          navbarBg = event.target.value;

          themeBg.forEach((className) => {
            appNavbar.classList.remove(className);
          });

          if (themeBg.includes(navbarBg)) {
            appNavbar.classList.add(navbarBg);
          }

          updateNavbar();
        });
      });

      document.addEventListener('DOMContentLoaded', () => {
        const appFooter = document.querySelector('.app-footer');
        const footerColorModes = document.querySelector('#footer-color-modes');
        const footerColor = document.querySelector('#footer-color');
        const footerColorCode = document.querySelector('#footer-color-code');

        const themeBg = [
          'bg-primary',
          'bg-primary-subtle',
          'bg-secondary',
          'bg-secondary-subtle',
          'bg-success',
          'bg-success-subtle',
          'bg-danger',
          'bg-danger-subtle',
          'bg-warning',
          'bg-warning-subtle',
          'bg-info',
          'bg-info-subtle',
          'bg-light',
          'bg-light-subtle',
          'bg-dark',
          'bg-dark-subtle',
          'bg-body-secondary',
          'bg-body-tertiary',
          'bg-body',
          'bg-black',
          'bg-white',
          'bg-transparent',
        ];

        // loop through each option themeBg array
        document.querySelector('#footer-color').innerHTML = themeBg.map((bg) => {
          // return option element with value and text
          return `<option value="${bg}" class="text-${bg}">${bg}</option>`;
        });

        let footerColorMode = '';
        let footerBg = '';

        function updateFooter() {
          appFooter.setAttribute('data-bs-theme', footerColorMode);
          footerColorCode.innerHTML = `<pre><code class="language-html">&lt;footer class="app-footer ${footerBg}" data-bs-theme="${footerColorMode}"&gt;...&lt;/footer&gt;</code></pre>`;
        }

        footerColorModes.addEventListener('input', (event) => {
          footerColorMode = event.target.value;
          updateFooter();
        });

        footerColor.addEventListener('input', (event) => {
          footerBg = event.target.value;

          themeBg.forEach((className) => {
            appFooter.classList.remove(className);
          });

          if (themeBg.includes(footerBg)) {
            appFooter.classList.add(footerBg);
          }

          updateFooter();
        });
      });
    </script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
