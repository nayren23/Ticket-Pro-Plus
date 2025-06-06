<?php

namespace TicketProPlus\App\Modules\User;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();


class UserView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function showUserForm($userToEdit = null)
    {
        $title = ($userToEdit === null) ? 'Sign up | Ticket Pro +' : 'Edit User | Ticket Pro +';
        $heading = ($userToEdit === null) ? 'Add a user' : 'Edit User';
        $action = ($userToEdit === null) ? 'index.php?module=user&action=addUser' : 'index.php?module=user&action=updateUser';
        $loginValue = htmlspecialchars($userToEdit['u_login'] ?? '');
        $firstnameValue = htmlspecialchars($userToEdit['u_firstname'] ?? '');
        $lastnameValue = htmlspecialchars($userToEdit['u_lastname'] ?? '');
        $emailValue = htmlspecialchars($userToEdit['u_email'] ?? '');
        $phoneValue = htmlspecialchars($userToEdit['u_phone_number'] ?? '');
        $descriptionValue = htmlspecialchars($userToEdit['u_description'] ?? '');
        $roleId = htmlspecialchars($userToEdit['r_id'] ?? '');
        $genderValue = htmlspecialchars($userToEdit['u_gender'] ?? '');

?>
        <title> <?= $title ?> </title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" action="<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>

                    <?php if ($userToEdit !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($userToEdit['u_id']) ?>">
                    <?php endif; ?>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="login" id="login"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="<?= $loginValue ?>" required <?= ($userToEdit !== null) ? 'readonly' : '' ?> />
                        <label for="login"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Login</label>
                    </div>

                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="firstname" id="firstname"
                                class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="<?= $firstnameValue ?>" required />
                            <label for="firstname"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                                name</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="lastname" id="lastname"
                                class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="<?= $lastnameValue ?>" required />
                            <label for="lastname"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                                name</label>
                        </div>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="email"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="<?= $emailValue ?>" required />
                        <label for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="tel" pattern="[0-9]{10}" name="phone" id="phone" maxlength="10"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="<?= $phoneValue ?>" />
                        <label for="phone"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                            number</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            Choose a role</label>
                        <select id="role" name="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="3" <?= ($roleId === '3') ? 'selected' : '' ?>>Reporter</option>
                            <option value="2" <?= ($roleId === '2') ? 'selected' : '' ?>>Developer</option>
                            <option value="1" <?= ($roleId === '1') ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>

                    <label class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400" for="file_input">Upload
                        file</label>
                    <input name="file_input"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input" id="pfp" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input">
                        SVG, PNG, JPG or GIF (MAX. 800x400px).</p>

                    <div class="relative z-0 w-full mb-5 group mt-5">
                        <label for="gender" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            Select your gender</label>
                        <select id="gender" name="gender"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="2" <?= ($genderValue === '2') ? 'selected' : '' ?>>Rather not say</option>
                            <option value="0" <?= ($genderValue === '0') ? 'selected' : '' ?>>Male</option>
                            <option value="1" <?= ($genderValue === '1') ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Your
                            description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Leave a description of you..."><?= $descriptionValue ?></textarea>
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <?= ($userToEdit === null) ? 'Submit' : 'Save Changes' ?>
                    </button>
                </form>
            </div>
        </div>
    <?php
    }

    public function manageUser($users, $currentPage, $totalPages, $totalUsers)
    {
    ?>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Login
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Password set
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                    ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                <?= $user["u_login"] ?>
                            </td>
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="public/<?= $user["u_profile_picture"] ?>"
                                    alt="Image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        <?= $user["u_firstname"] . " " . $user["u_lastname"]  ?>
                                    </div>
                                    <div class="font-normal text-gray-500"><?= $user["u_email"] ?></div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <?= $user["r_name"] ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-2.5 w-2.5 rounded-full <?= $user["password_set"] === 1 ? "bg-green-500" : "bg-red-500"  ?> me-2">
                                    </div>
                                    <?= $user["password_set"] === 1 ? "Yes" : "No" ?>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <a href="?module=user&action=showEditUserForm&id=<?= htmlspecialchars($user['u_id']); ?>"
                                        type="button"
                                        data-modal-target="editUserModal"
                                        data-modal-show="editUserModal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">Edit user</a>
                                </div>
                                <div>
                                    <a href="?module=user&action=editPasswordForm&id=<?= htmlspecialchars($user['u_id']); ?>"
                                        type="button"
                                        data-modal-target="editUserModal"
                                        data-modal-show="editUserModal"
                                        class="font-medium text-teal-600 dark:text-teal-500 hover:underline block">Edit password</a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <!-- Delete User -->
                                <a data-user-id="<?= htmlspecialchars($user['u_id']); ?>" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="button">
                                    Delete user
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <nav class="flex items-center justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing <span class="font-semibold text-gray-900 dark:text-white"><?= count($users) ?></span> of <span class="font-semibold text-gray-900 dark:text-white"><?= $totalUsers ?></span>
                </span>
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="?module=user&action=manageUser&page=<?= max(1, $currentPage - 1) ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li>
                            <a href="?module=user&action=manageUser&page=<?= $i ?>" class="<?= $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' ?> flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 dark:border-gray-700"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li>
                        <a href="?module=user&action=manageUser&page=<?= min($totalPages, $currentPage + 1) ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    </li>
                </ul>
            </nav>
            <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this user ?</h3>
                            <button data-user-id="<?php echo htmlspecialchars($user['u_id']); ?>" data-modal-hide="popup-modal" type="button" class="delete-user-link text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php
    }

    public function updatePasswordForm($userId)
    {
    ?>
        <title> Edit Password </title>
        <div class="mt-6">

            <form id="passwordStrengthForm" class="max-w-md mx-auto" method="POST" action="index.php?module=user&action=updatePassword&id=<?= htmlspecialchars($userId); ?>" method="POST">
                <h2 class="text-4xl font-extrabold dark:text-white mb-6">Edit Password</h2>

                <div class="mb-6 relative">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pe-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 end-0 pe-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Password must be at least <span class="font-semibold">Strong</span>.</p>
                    <div id="passwordStrengthMeter" class="bg-gray-200 rounded-full h-2.5 mt-2 dark:bg-gray-700">
                        <div id="passwordStrengthBar" class="bg-red-500 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <p id="passwordStrengthText" class="mt-2 text-sm text-gray-500 dark:text-gray-400"></p>
                </div>
                <div class="mb-6 relative">
                    <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pe-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
                        <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 end-0 pe-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i id="confirmEyeIcon" class="fa fa-eye"></i>
                        </button>
                    </div>
                    <p id="passwordMatchError" class="mt-2 text-sm text-red-500 hidden dark:text-red-400">The passwords do not match.</p>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Modifier le mot de passe</button>
            </form>
        </div>
    <?php
    }

    public function viewUser($user)
    {
        $title = 'View an User | Ticket Pro +';
        $heading = 'View an User';
        $loginValue = htmlspecialchars($user['u_login']);
        $firstnameValue = htmlspecialchars($user['u_firstname'] ?? '');
        $lastnameValue = htmlspecialchars($user['u_lastname'] ?? '');
        $emailValue = htmlspecialchars($user['u_email'] ?? '');
        $phoneValue = htmlspecialchars($user['u_phone_number'] ?? '');
        $descriptionValue = htmlspecialchars($user['u_description'] ?? '');
        $roleId = htmlspecialchars($user['r_id'] ?? '');
        $genderValue = htmlspecialchars($user['u_gender'] ?? '');

    ?>
        <title> <?= $title ?> </title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" enctype="multipart/form-data">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="login" id="login"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $loginValue ?>" required disabled />
                        <label for="login"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Login</label>
                    </div>

                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="firstname" id="firstname"
                                class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                                placeholder=" " value="<?= $firstnameValue ?>" required disabled />
                            <label for="firstname"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                                name</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="lastname" id="lastname"
                                class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                                placeholder=" " value="<?= $lastnameValue ?>" required disabled />
                            <label for="lastname"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                                name</label>
                        </div>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="email"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $emailValue ?>" required disabled />
                        <label for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="tel" pattern="[0-9]{10}" name="phone" id="phone" maxlength="10"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $phoneValue ?>" disabled />
                        <label for="phone"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                            number</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400 cursor-not-allowed" disabled>
                            Role</label>
                        <select id="role" name="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" disabled>
                            <option value="3" <?= ($roleId === '3') ? 'selected' : '' ?>>Reporter</option>
                            <option value="2" <?= ($roleId === '2') ? 'selected' : '' ?>>Developer</option>
                            <option value="1" <?= ($roleId === '1') ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>

                    <div class="relative z-0 w-full mb-5 group mt-5 cursor-not-allowed">
                        <label for="gender" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400" disabled>
                            Gender </label>
                        <select id="gender" name="gender"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" disabled>
                            <option value="2" <?= ($genderValue === '2') ? 'selected' : '' ?>>Rather not say</option>
                            <option value="0" <?= ($genderValue === '0') ? 'selected' : '' ?>>Male</option>
                            <option value="1" <?= ($genderValue === '1') ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>

                    <div class="relative z-0 w-full mb-5 group cursor-not-allowed">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400" disabled> User
                            description</label>
                        <textarea disabled id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                            placeholder="Leave a description of you..."><?= $descriptionValue ?> </textarea>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
