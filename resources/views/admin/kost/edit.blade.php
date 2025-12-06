<h2>Edit Data Kost ID: {{ $id }}</h2>
<form action="#" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" placeholder="Nama Kost">
    <button type="submit">Update</button>
</form>
