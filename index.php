<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <link href="css/base.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/menu.js"></script>
    </head>
    <body>
        <main>
            <div id="topbar">
                <div class="topbar__wrapper-logo">
                    <span style="font-size: 3rem;">🍔 </span>
                    <span class="open-menu-btn"><img loading="lazy" src="src/icons/arrow_back_FILL0_wght400_GRAD0_opsz24.svg"></span>
                </div>
                <div class="topbar__wrapper-account">
                    <div class="topbar__wrapper-account__inner-wrapper">
                        <div class="topbar__wrapper-account__inner-wrapper__foto">
                            <span style="font-size: 3rem;">😉</span>
                        </div>
                        <div class="topbar__wrapper-account__inner-wrapper__nome">José Alves</div>
                    </div>
                </div>
            </div>
            <div id="sidebar">
                <ul>
                    <li>
                        <div class="dropdown">
                            <span>Mouse over me</span>
                            <div class="dropdown-content">
                                <p>Hello World!</p>
                            </div>
                        </div>
                    </li>
                    <li>Inventários</li>
                    <li>Agregados</li>
                    <li>Distribuição</li>
                </ul>


            </div>
            <div id="content">
                <div class="content-wrapper">
                    <div class="content__inner-wrapper">
                        <table>
                            <thead>
                            <tr>
                                <th>teste</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>teste</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <footer></footer>
    </body>
</html>