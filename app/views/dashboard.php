<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.2/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.2/assets/img/favicons/favicon.ico">
    <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="dashboard w-100 container m-auto">
    <h2 class="dashboard__title">User List</h2>


<!-- -->
    <div class="dashboard_loading mx-sm-4">
        <img src="/assets/images/darkyoshi973.gif" alt="Loading..." />
    </div>
    <div class="dashboard_result mx-sm-4 d-none">
        <table class="dashboard_result__table table table-striped w-100 mt-3">
            <thead>
            <tr>
                <td colspan="3"></td>
            </tr>
            </thead>
            <tbody>
                <?php // TODO: remove, script just for debug

                use app\core\helpers\StudentsSeeder;

                foreach (array_slice(StudentsSeeder::getTestUsersData(), 0,5) as $row) : ?>
                    <tr>
                        <td>
                            <?php if ($row['active']) : ?><i class="dashboard_result__table__status_on bi bi-check-circle-fill"></i>
                            <?php else : ?><i class="dashboard_result__table__status_off bi bi-circle"></i><?php endif ?>
                        </td>
                        <td>
                            <p class="dashboard_result__table__login"><?= $row['login'] ?></p>
                            <p class="dashboard_result__table__user_name"><?= $row['user_name'] ?></p>
                        </td>
                        <td>
                            <p class="dashboard_result__table__title"><?= $row['title'] ?></p>
                            <p class="dashboard_result__table__group"><?= $row['group'] ?></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">
                    <nav>
                        <ul class="pagination justify-content-center" id="dashboard_result__pagination">

                            <li class="page-item dashboard_result__pagination_to_prev">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item dashboard_result__pagination_to_next">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span class="sr-only">Next</span>
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
<!-- --->


    <footer class="dashboard__footer py-3 fixed-bottom">
        <div class="container-fluid text-center">
            <a href="#" onclick="return dashboard.userLogout();" class="dashboard__footer-logout-link">
                <i class="bi bi-box-arrow-right me-2"></i> Log Out
            </a>
        </div>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
<script src="/assets/js/dashboard.js"></script>

</body>
</html>
