

<h1>testin video api</h1>
<form action="{{url('api/resources/1')}}" method="POST" enctype="multipart/form-data">
    <input type="file" name="resource">
    <input type="hidden" name="_method" value="PUT">
    <button type="submit">Enviame Papi</button>
</form>