<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                <p class="lead mb-4">Your Laravel application with admin panel is ready!</p>
                
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-lg px-4 gap-3">
                        <i class="fas fa-tachometer-alt me-2"></i>Go to Admin Panel
                    </a>
                </div>

                <div class="mt-5">
                    <h3>Features:</h3>
                    <ul class="list-unstyled">
                        <li>✅ Admin Panel with Dashboard</li>
                        <li>✅ Banner Management</li>
                        <li>✅ About Us Management</li>
                        <li>✅ User Authentication</li>
                        <li>✅ Responsive Design</li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
