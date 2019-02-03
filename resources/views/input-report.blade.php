<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
          crossorigin="anonymous">

    <title>Title</title>
</head>

<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">Name</a>
</nav>

<form class="p-3">
    <div class="form-group" style="width: 30%">
        <label for="branch">Select branch</label>
        <select name="branch" id="branch" class="form-control">
            <option hidden selected value="null">Select...</option>
            <option value="">Branch #1</option>
            <option value="">Branch #2</option>
            <option value="">Branch #3</option>
        </select>
    </div>

    <table class="table">

        <thead>
        <tr>
            <th scope="col">Models</th>
            <th scope="col">Display Qty</th>
            <th scope="col">Talker</th>
            <th scope="col">Flyer</th>
            <th scope="col">Streamer</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <th scope="row">Model name</th>
            <td>
                <input type="number" min=0 max=999 name="display-qty" class="form-control">
            </td>
            <td>
                <input type="number" min=0 max=999 name="talker" class="form-control">
            </td>
            <td>
                <input type="number" min=0 max=999 name="flyer" class="form-control">
            </td>
            <td>
                <input type="number" min=0 max=999 name="streamer" class="form-control">
            </td>
        </tr>
        </tbody>

    </table>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>

</form>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
</body>

</html>