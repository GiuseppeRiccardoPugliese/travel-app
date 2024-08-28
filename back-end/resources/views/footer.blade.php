<footer class="footer text-white ">
    <div class="container text-center flex-wrap justify-content-between align-items-center">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <span>&copy; {{ date('Y') }} Travel-App</span>
            </div>
            <div class="col-md-6">
                <a href="http://localhost:5174/about-us">About Us</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #1E90FF;
        padding: 1.5rem 0;

        a {
            color: #ffffff;
            text-decoration: none;

            &:hover {
                color: #f8f9fa;
                text-decoration: underline;
            }
        }

    }
</style>
