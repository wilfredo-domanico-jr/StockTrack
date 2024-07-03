<form action="/submit-form" method="POST">
    @csrf
    @method('DELETE')
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br>

    <button type="submit">Submit</button>
</form>