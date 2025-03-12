<!-- Menu Button (Fixed Position) -->
<button 
    data-drawer-target="separator-sidebar" 
    data-drawer-toggle="separator-sidebar" 
    aria-controls="separator-sidebar" 
    type="button" 
    class="fixed top-4 left-4 z-50 inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-[#D3D9D4] focus:outline-none focus:ring-2 focus:ring-[#748D92] dark:text-gray-400 dark:hover:bg-[#2E3944] dark:focus:ring-[#124E66]">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<!-- Sidebar -->
<aside id="separator-sidebar" class="fixed sm:top-0 top-20 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-[#D3D9D4] dark:bg-[#212A31]" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto">
      <ul class="space-y-2 font-medium sm:mt-[60px] mt-[60px]">
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-[#748D92] dark:hover:bg-[#2E3944] group">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         <li>
         <?=loadComponent("ThemeToggle") ?>
         </li>
         <li>
            <a href="/logout" class="flex items-center p-2 rounded-lg dark:text-white hover:bg-[#748D92] dark:hover:bg-[#2E3944] group dark:hover:text-red-500">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M10.09 15.59L12.67 13H4V11H12.67L10.09 8.41L11.5 7L16.5 12L11.5 17L10.09 15.59ZM20 3H14V1H20C21.1 1 22 1.9 22 3V21C22 22.1 21.1 23 20 23H14V21H20V3Z"/>
               </svg>
               <span class="ms-3">Logout</span>
            </a>
         </li>
      </ul>
   </div>
</aside>