<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Student Attendance</h2>
        <form id="attendance-form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Upload Face Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div id="response-message" class="mt-3"></div>
    </div>

    <script>
        const form = document.getElementById('attendance-form');
        const responseMessage = document.getElementById('response-message');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(form);
            try {
                const response = await fetch('/verify-face', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                responseMessage.innerHTML = `
                    <div class="alert ${result.status === 'success' ? 'alert-success' : 'alert-danger'}">
                        ${result.message}
                    </div>
                `;
            } catch (error) {
                responseMessage.innerHTML = `
                    <div class="alert alert-danger">An error occurred. Please try again.</div>
                `;
            }
        });
    </script>
</body>
</html>
