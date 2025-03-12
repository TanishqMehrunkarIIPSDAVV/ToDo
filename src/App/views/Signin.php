<?=
loadComponent("Head");
?>
<div class="bg-[#D3D9D4] dark:bg-[#212A31] flex items-center justify-center h-screen">
    <div class="bg-white dark:bg-[#2E3944] p-8 rounded-2xl shadow-xl w-96 border border-[#BAB2B5] dark:border-[#124E66]">
        <?= isset($msg) ? loadComponent("SuccessAlert",["msg"=>$msg ?? ""]) : ""?>
        <?=loadComponent("ErrorAlert",["errors"=>$errors ?? []])?>
        <h2 class="text-2xl font-bold text-[#212A31] dark:text-[#D3D9D4] text-center poppins-bold">Sign In</h2>
        <form class="mt-6" method="post" action="/signin">
            <div>
                <label class="block text-[#212A31] dark:text-[#D3D9D4] font-medium poppins-regular">Email</label>
                <input required name="signin-email" type="email" class="poppins-regular w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#124E66] dark:bg-[#D3D9D4] dark:text-black dark:border-[#D3D9D4]" placeholder="Enter your email">
            </div>
            <div class="mt-4 relative">
                <label class="block text-[#212A31] dark:text-[#D3D9D4] font-medium poppins-regular">Password</label>
                <input required name="signin-password" type="password" class="poppins-regular w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#124E66] dark:bg-[#D3D9D4] dark:text-black dark:border-[#D3D9D4]" placeholder="Enter your password">
                <?=loadComponent("EyeIcons") ?>
            </div>
            <button type="submit" class="poppins-semibold w-full mt-6 bg-[#124E66] dark:bg-[#748D92] text-white dark:text-black font-semibold py-2 rounded-lg hover:bg-[#0E3C50] dark:hover:bg-[#D3D9D4] transition-all shadow-md dark:shadow-lg">Sign In</button>
            <div class="mt-4 sm:gap-4 flex sm:flex-row justify-center flex-col items-center gap-3">
                <a href="/forgot-password" class="poppins-regular text-[#212A31] dark:text-[#d3d9d4] font-medium hover:underline transition-all text-center">Forgot Password</a>
                <a href="/signup" class="poppins-regular text-[#212A31] dark:text-[#d3d9d4] font-medium hover:underline transition-all text-center">Create an Account</a>
            </div>

        </form>
    </div>
    <?= loadComponent("ThemeToggle") ?>
</div>
<?=
loadComponent("Tail");
?>