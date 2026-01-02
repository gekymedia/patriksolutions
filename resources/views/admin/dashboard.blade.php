<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->name }} | {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="wrapper">
                    <div class="container mt-5">
                        <div class="d-flex flex-column align-items-center">

                            @if (session('success'))
                                <div class="toast toast-custom bg-success text-white" role="alert" aria-live="assertive"
                                    aria-atomic="true" data-delay="500">
                                    <div class="toast-header">
                                        <strong class="me-auto">Success</strong>
                                        <small>Just now</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            <!-- cards -->
                            <div class="row justify-content-center g-4">
                                <!-- Custom class added for styling -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-body d-flex flex-column">
                                            <h3 class="card-title text-danger"><i class="fas fa-users fa-1x mb-3"></i>
                                                Users</h3>
                                            <p class="card-text">Manage your black tasks efficiently with our
                                                comprehensive tracking system. Stay on top of deadlines and enhance
                                                productivity.</p>
                                            <a href="{{ route('users.index') }}" class="btn btn-danger mt-auto">Go to
                                                Users <i class="fas fa-paper-plane"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-warning"><i
                                                    class="fas fa-dashboard fa-1x mb-3"></i> Blog</h5>
                                            <p class="card-text">Write a blog and get to the audience of Patrick
                                                Solutions who are eagerly waiting</p>
                                            <a href="{{ route('blogs.index') }}"
                                                class="btn btn-warning mt-auto text-white mb-2">Go to Blog Posts
                                                <i class="fas fa-paper-plane"></i>
                                            </a>
                                            <a href="{{ route('admin.blog-notifications.index') }}"
                                                class="btn btn-info mt-auto text-white">
                                                <i class="fas fa-bell me-1"></i>View Subscribers
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-success"><i class="fas fa-eye fa-1x mb-3"></i>
                                                Courses</h5>
                                            <p class="card-text">Track and record your presence with ease. Our tool
                                                ensures you never miss a moment and keeps accurate records for your
                                                needs.</p>
                                            {{-- <a href="{{ route('admin.presenceKeepings.index') }}" class="btn btn-success mt-auto text-white">Go to Presence
                                                Keeping <i class="fas fa-paper-plane"></i>
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-info"><i class="fas fa-tasks fa-1x mb-3"></i>
                                                Course Enrollment</h5>
                                            <p class="card-text">Track </p>
                                            {{-- <a href="{{ route('admin.task_bones.index') }}" class="btn btn-info mt-auto text-white">Go to Task Bone <i
                                                    class="fas fa-paper-plane"></i></a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- cards ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card .card-body {
        display: flex;
        flex-direction: column;
    }

    .toast-custom {
        position: fixed !important;
        top: 90px !important;
        right: 20px;
        min-width: 250px;
        max-width: 400px;
        padding: 15px;
        background-color: #198754;
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, .4);
        transform: translateY(-30px);
        transition: all.5s ease-out;
    }

    .toast-custom.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast-custom.toast-header strong {
        font-size: 18px;
    }

    .custom-toast.toast-body {
        font-size: 14px;
    }
</style>
<script>
    $(document).ready(function() {
        // Check if session success message exists
        @if (session('success'))
            // Select toast element
            var toastEl = document.querySelector('.toast-custom');

            // Show the toast message
            var toast = new bootstrap.Toast(toastEl);
            toast.show();

            // Remove the toast after a delay
            setTimeout(function() {
                toastEl.remove();
            }, 500); // Adjust the delay time if needed
        @endif
    });
</script>
