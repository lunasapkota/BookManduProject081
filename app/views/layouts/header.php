<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/css/styles.css">

    <style>
        #profile:hover+.profile_info_float {
            display: block;
        }

        .profile_info_float:hover {
            display: block;
        }
    </style>

</head>

<body>
    <header
        class="navbar z-50 bg-white fixed top-0 left-0 w-full px-4 md:px-8 border shadow-lg h-20 flex items-center justify-between">

        <div class="ml-16 logo_name flex items-center space-x-4">
            <i class="drawer md:hidden fa fa-bars text-xl text-gray-700 px-2 hover:bg-gray-300 active:bg-gray-400 rounded-lg cursor-pointer"
                aria-hidden="true"></i>

            <span class="text-3xl font-bold text-blue-900">BookMandu</span>
        </div>

        <div class="phoneNav hidden z-50 fixed top-0 left-0 h-full w-2/3 sm:w-1/2 bg-gray-100 rounded-lg p-6 shadow-lg md:hidden">
            <ul class="flex flex-col gap-4">
                <li class="p-2 hover:bg-gray-300 active:bg-gray-400 rounded-lg"><a href="/login">Login</a></li>
                <li class="p-2 hover:bg-gray-300 active:bg-gray-400 rounded-lg"><a href="/register">Sign Up</a></li>
                <li class="p-2 hover:bg-gray-300 active:bg-gray-400 rounded-lg"><a href="/books">Sell Book</a></li>
            </ul>
        </div>

        <div class="searchbar relative  mx-4">
            <input type="text" class="w-[30vw] bg-gray-200 rounded-lg py-2 px-4 outline-none focus:outline-gray-400"
                placeholder="Search here">
            <i class="absolute right-3 top-1/2 -translate-y-1/2  text-gray-700 outline-none  hover:bg-gray-400 active:bg-gray-500 text-xl fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="authbtn hidden md:flex items-center gap-4 text-lg text-blue-900">
            <?php if (!$auth) { ?>
                <a class="hover:text-black" href="/register">Sign Up</a>
                <a class="hover:text-black" href="/login">Login</a>
            <?php } else { ?>
                <a href="/login" id="profile" class="hover:text-black flex items-center gap-2">
                    <!-- <?php echo $user->photo ?> -->
                    <div class="profile_image relative ">
                        <img class="h-[50px] w-[50px] rounded-full hover:opacity-80" src="<?php echo $user->photo ?>" alt="">

                        <div class="profile_info_float hidden absolute top-[100%] left-0 bg-white rounded-lg p-4">
                            <?php echo $user->name ?>
                            <a class="hover:text-black" href="/logout">Logout</a>

                        </div>
                    </div>
                    <!-- <i class="fa-solid fa-user text-3xl text-blue-900 hover:text-blue-600 active:text-blue-500"></i> -->
                </a>
            <?php } ?>
        </div>

        <button class="mx-16 sellbtn hidden md:block bg-blue-900 text-white p-2 rounded-lg"><a class="hover:text-black mx-2" href="/books">Sell Book</a></button>
    </header>

    <script>
        const drawerIcon = document.querySelector('.drawer');
        const phoneNav = document.querySelector('.phoneNav');

        drawerIcon.addEventListener('click', () => {
            phoneNav.classList.toggle('hidden');
        });
    </script>

    <div class="mt-20">