@if (session('success'))
    <div class="alert alert-success mb-4">
        <div>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6 inline"
            >
                <path
                    fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-2.69a.75.75 0 1 0-1.22-.87l-3.236 4.53-1.543-1.543a.75.75 0 0 0-1.06 1.06l2.17 2.17a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd"
                />
            </svg>

            {{ session('success') }}
        </div>
    </div>
@endif