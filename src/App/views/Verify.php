<?=
loadComponent("Head");
?>
<div class="bg-[#D3D9D4] dark:bg-[#212A31] flex items-center justify-center h-screen">
    <div class="bg-white dark:bg-[#2E3944] p-8 rounded-2xl shadow-xl w-96 border border-[#BAB2B5] dark:border-[#124E66]">
        <?=loadComponent("ErrorAlert",["errors"=>$errors ?? []])?>
        <?=loadComponent("WarningAlert",["msg"=>'Please Verify by using your Email Address. A Code has been sent to you!!!'])?>
        <h2 class="text-2xl font-bold text-[#212A31] dark:text-[#D3D9D4] text-center poppins-bold">Verification</h2>
        <form class="mt-6" action="/verification" method="post">
            <div>
                <label class="block text-[#212A31] dark:text-[#D3D9D4] font-medium poppins-regular">Email</label>
                <input name="verify_email" type="email" class="poppins-regular w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#124E66] dark:bg-[#D3D9D4] dark:text-black dark:border-[#D3D9D4]" placeholder="Enter your email">
            </div>
            <div class="mt-4">
                <label class="block text-[#212A31] dark:text-[#D3D9D4] font-medium poppins-regular">Code</label>
                <input name="verify_code" type="tel" class="poppins-regular w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#124E66] dark:bg-[#D3D9D4] dark:text-black dark:border-[#D3D9D4]" placeholder="Enter the code">
            </div>
            <button type="submit" class="poppins-bold w-full mt-6 bg-[#124E66] dark:bg-[#748D92] text-white dark:text-black font-semibold py-2 rounded-lg hover:bg-[#0E3C50] dark:hover:bg-[#D3D9D4] transition-all shadow-md dark:shadow-lg">Verify</button>
            <center class="mt-3">
                <a href="/" class="poppins-regular text-[#212A31] dark:text-[#d3d9d4] font-medium hover:underline transition-all text-center">Sign In</a>
            </center>
        </form>
    </div>
    <?= loadComponent("ThemeToggle") ?>
</div>
<?=
loadComponent("Tail");
?>