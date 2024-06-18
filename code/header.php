<body>
    <div
      class="page-wrapper"
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin6"
      data-sidebartype="full"
      data-sidebar-position="fixed"
      data-header-position="fixed">
      <aside class="left-sidebar">
        <div>
          <div
            class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.php" class="text-nowrap logo-img">
              <img src="../assets/images/LOGO.png" width="180" alt="" />
            </a>
            <div
              class="close-btn d-xl-none d-block sidebartoggler cursor-pointer"
              id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
          <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./index.php"
                  aria-expanded="false">
                  <span>
                    <i class="ti ti-layout-dashboard"></i>
                  </span>
                  <span class="hide-menu">Dashboard</span>
                </a>
              </li>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Finance</span>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./transaction.php"
                  aria-expanded="false">
                  <span>
                    <i class="ti ti-moneybag"></i>
                  </span>
                  <span class="hide-menu">Transaction</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./report.php"
                  aria-expanded="false">
                  <span>
                    <i class="ti ti-report"></i>
                  </span>
                  <span class="hide-menu">Report</span>
                </a>
              </li>
              <?php if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Owner'):?>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Procurement</span>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./product.php"
                  aria-expanded="false">
                  <span>
                    <i class="ti ti-box"></i>
                  </span>
                  <span class="hide-menu">Product</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./stock.php"
                  aria-expanded="false">
                  <span>
                    <i class="ti ti-package"></i>
                  </span>
                  <span class="hide-menu">Stock</span>
                </a>
              </li>
              <?php 
              endif;
              if($_SESSION['role'] == 'Owner'): ?>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Data</span>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./user.php"
                  aria-expanded="false">
                  <span>
                    <i class="ti ti-users"></i>
                  </span>
                  <span class="hide-menu">User</span>
                </a>
              </li>
              <?php endif;?>
            </ul>
          </nav>
        </div>
      </aside>
      <div class="body-wrapper">
        <header class="app-header">
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item d-block d-xl-none">
                <a
                  class="nav-link sidebartoggler nav-icon-hover"
                  id="headerCollapse"
                  href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
            </ul>
            <div
              class="navbar-collapse justify-content-end px-0"
              id="navbarNav">
              <ul
                class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <a
                  href="logout.php"
                  target="_blank"
                  class="btn btn-primary"
                  >Sign Out</a
                >
              </ul>
            </div>
          </nav>
        </header>