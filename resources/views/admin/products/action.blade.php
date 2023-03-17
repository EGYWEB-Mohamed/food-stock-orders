<a href="{{ route('products.edit',$id) }}" class="btn btn-sm btn-primary">Update</a>
<form class="d-inline-block" method="post" action="{{ route('products.destroy',$id) }}"
      onsubmit="return confirm('Are you sure you want to delete?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>
