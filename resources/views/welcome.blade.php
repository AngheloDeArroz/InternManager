<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Tracker Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="max-w-5xl w-full px-6">
        <div class="grid md:grid-cols-2 gap-10 items-center">

            <div>
                <h1 class="text-5xl font-bold text-blue-600 mb-4">
                    InternTracker
                </h1>
                <p class="text-2xl text-gray-800">
                    Track internship tasks, progress, and remaining hours in one place.
                </p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Email address"
                            class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring focus:border-blue-500"
                        >
                    </div>

                    <div class="mb-4">
                        <input
                            type="password"
                            name="password"
                            required
                            placeholder="Password"
                            class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring focus:border-blue-500"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white text-lg font-semibold py-3 rounded-md hover:bg-blue-700 transition"
                    >
                        Log In
                    </button>

                    @if ($errors->any())
                        <div class="mt-4 text-sm text-red-600">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </form>

        </div>
    </div>

</body>
</html>
