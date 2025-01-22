<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Inactive</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-base font-semibold text-indigo-600">Account Inactive</p>
            <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Your account is inactive</h1>
            <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">
                Please contact support for more information.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
                <a href="/dashboard" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Refresh Page
                </a>
                    <button type="submit" class="text-sm font-semibold text-gray-900 ml-5">
                    Log out <span aria-hidden="true">&rarr;</span>    
                    </button>   
                </form>
            </div>
        </div>
    </main>
</body>
</html>
