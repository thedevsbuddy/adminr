<footer class="bg-white sticky-footer">
    <div class="container my-auto py-3">
        <div class="my-auto copyright d-flex justify-content-between align-items-center">
            <span>Copyright ©
                <a href="https://devsbuddy.com" target="_blank" class="font-weight-bold">Devsbuddy</a>
                {{ date('Y') }}. All rights reserved.
            </span>
            <span>Version: <strong>{{ adminr('version', prefix: "v") }}</strong></span>
        </div>
    </div>
</footer>
