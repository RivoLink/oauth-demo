<?php
    if(!is_auth()){
        header('Location: '.base_url());
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>OAuth Demo - Dashboard</title>

        <meta name="author" content="Xiaoying Riley at 3rd Wave Media" />
        <link rel="shortcut icon" href="/favicon.png" type="image/x-icon"/>

        <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/assets/plugins/portal/css/portal.css" />
        <link rel="stylesheet" href="/assets/css/dashboard.css" />
    </head>

    <body class="app">
        <header class="app-header fixed-top py-1">
            <div class="app-header-inner">
                <div class="container-fluid py-2">
                    <div class="app-header-content">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                                        <title>Menu</title>
                                        <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="app-utilities col-auto">
                                <div class="app-utility-item app-user-dropdown dropdown">
                                    <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                fill-rule="evenodd"
                                                d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"
                                            />
                                            <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
                                        </svg>
									</a>
                                    <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                        <li><a class="dropdown-item" href="/logout">Log out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="app-sidepanel" class="app-sidepanel sidepanel-hidden">
                <div id="sidepanel-drop" class="sidepanel-drop"></div>
                <div class="sidepanel-inner d-flex flex-column">
                    <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                    <div class="app-branding">
                        <div class="app-logo" href="#">
                            <img class="logo-icon me-2" src="/assets/images/logo.png" alt="logo" />
                            <span class="logo-text">OAuth Demo</span>
                        </div>
                    </div>
                    <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                        <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <span class="nav-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-text">Users</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <div class="app-wrapper">
            <div class="app-content pt-3 p-md-3 p-lg-4">
				<div class="container-xl">

                    <div class="app-card bg-light shadow-sm mb-3">
                        <div class="inner">
                            <div class="app-card-body p-1">
                                <div class="row gx-5 gy-3">
                                    <div class="text-dark fw-bold py-2">
                                        <span class="app-title-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </span>
                                        <span class="mx-2">Users</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="app-card bg-light shadow-sm mb-4">
                        <div class="inner">
                            <div class="app-card-body p-1">
                                <div class="row gx-5 gy-3">
                                    <div>
                                        <table class="table table-light table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="20%"scope="col">ID</th>
                                                    <th width="20%"scope="col">Name</th>
                                                    <th width="20%"scope="col">Platform</th>
                                                    <th width="40%"scope="col">Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">62fe2fad1f09a</th>
                                                    <td>Mark Otto</td>
                                                    <td>Google</td>
                                                    <td>mark.otto@example.com</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">62fe2fb9644eb</th>
                                                    <td>Jennie Nichols</td>
                                                    <td>Facebook</td>
                                                    <td>jennie.nichols@example.com</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">62fe2fc3a333f</th>
                                                    <td>Jacob Thornton</td>
                                                    <td>Google</td>
                                                    <td>jacob.thornton@example.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
            </div>
        </div>

        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/plugins/portal/js/portal.js"></script>
    </body>
</html>
