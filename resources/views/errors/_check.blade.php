@if($errors->any())
<div class="alert alert-danger" data-dismiss="alert" aria-label="Close">
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Oops!!</strong> Aconteceram alguns erros.
    <br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif