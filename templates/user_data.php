<?php
/**
 * Template Name: User Manager Template
 */

get_header();
?>

<div class="content-area min-h-screen bg-slate-50 py-10">
    <div id="crud-app" class="max-w-5xl mx-auto p-8 bg-white shadow-xl rounded-2xl border border-gray-100 font-sans">
        
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-indigo-700">User Directory</h1>
            <p class="text-gray-500 mt-2">Manage your users with real-time AJAX updates</p>
        </header>
        
        <!-- Form Section -->
        <section class="mb-10 p-6 bg-indigo-50 rounded-xl border border-indigo-100 shadow-inner">
            <form id="user-form" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="hidden" name="user_id" id="user_id">
                
                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-indigo-900 mb-1 ml-1">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="John Doe" required 
                           class="p-3 border-2 border-white bg-white rounded-lg focus:border-indigo-500 outline-none transition">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-indigo-900 mb-1 ml-1">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="john@example.com" required 
                           class="p-3 border-2 border-white bg-white rounded-lg focus:border-indigo-500 outline-none transition">
                </div>

                <div class="flex items-end">
                    <button type="submit" id="form-submit" 
                            class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transform hover:-translate-y-1 transition duration-200 shadow-md">
                        Add New User
                    </button>
                </div>
            </form>
        </section>

        <!-- Table Section -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="p-4 font-semibold uppercase text-sm tracking-wider">ID</th>
                        <th class="p-4 font-semibold uppercase text-sm tracking-wider">Name</th>
                        <th class="p-4 font-semibold uppercase text-sm tracking-wider">Email</th>
                        <th class="p-4 font-semibold uppercase text-sm tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="user-table-body" class="divide-y divide-gray-100">
                    <!-- AJAX data will load here -->
                </tbody>
            </table>
        </div>

        <!-- Footer Info -->
        <div class="mt-6 flex justify-between items-center text-sm text-gray-400">
            <p>* All updates are saved automatically via AJAX.</p>
            <div id="sync-status" class="hidden text-green-500 font-medium italic">✔ Synced with database</div>
        </div>
    </div>
</div>

<?php
get_footer(); ?>