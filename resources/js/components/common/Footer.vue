<template>
    <footer class="bg-gray-100 border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <!-- About -->
                <div class="flex-1">
                    <h3 class="font-bold text-lg mb-2">🌍 Review Places</h3>
                    <p class="text-gray-600 text-sm">
                        A web application that helps users discover, review, and share experiences
                        about various places such as restaurants, cafes, or check-in spots.
                    </p>
                </div>

                <!-- Features -->
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-700 mb-2">Main Features</h4>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li>Place Management</li>
                        <li>Reviews & Comments</li>
                        <li>User Profiles</li>
                        <li>Advanced Search & Filtering</li>
                    </ul>
                </div>

                <!-- Contact / Links -->
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-700 mb-2">Technologies</h4>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li>Backend: Laravel (REST API)</li>
                        <li>Frontend: Vue 3 + Vue Router</li>
                        <li>Database: MySQL</li>
                        <li>CSS: TailwindCSS</li>
                        <li>Map: LeafletJS / Google Maps API</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 border-t pt-4 text-center text-gray-500 text-sm">
                &copy; 2025 Review Places. All rights reserved.
            </div>
        </div>
    </footer>
</template>

<style scoped>
footer ul li::before {
    content: "•";
    margin-right: 0.25rem;
    color: #4B5563; /* gray-600 */
}
</style>
