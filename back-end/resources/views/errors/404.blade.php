<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
</head>

<body>
    <div class="container">
        <img src="https://media4.giphy.com/media/v1.Y2lkPTc5MGI3NjExNnFnbDdzMmxsMW5tNTJrN3ZrMHprbjBxaThwemgycGt4bWdjaGRmZSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3oFyD9bC0N65oZv53q/giphy.webp"
            alt="notFoundImg">
        <h1>404</h1>
        <h2>Oops! La pagina che stai cercando non esiste.</h2>
        <p>Potresti essere finito su una pagina che è stata spostata o che non è mai esistita.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Torna alla Home</a>
    </div>
</body>

</html>

<style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: 'Comfortaa', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        height: 100%;
    }

    h1 {
        font-size: 6rem;
        font-weight: 700;
        margin: 1rem 0;
        color: #dc3545;
    }

    h2 {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: #6c757d;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        text-decoration: none;
        color: #fff;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>
