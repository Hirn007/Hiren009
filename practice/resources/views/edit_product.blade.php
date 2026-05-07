@extends('layout.main')
@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-4">
      <h2>edit product</h2>


      <div class="container mt-3">
  
  <form action="">
    <div class="mb-3 mt-3">
      <label for="name">name</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
    </div>
    <div class="mb-3">
      <label for="price">price</label>
      <input type="text" class="form-control" id="price" placeholder="Enter price" name="price">
    </div>
    <div class="mb-3">
      <label for="image">image</label>
      <input type="text" class="form-control" id="image" placeholder="Enter image" name="image">
    </div>
    <div class="mb-3">
      <label for="description">description</label>
      <input type="text" class="form-control" id="description" placeholder="Enter description" name="description">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

  
       </div>
</div>
@endsection
