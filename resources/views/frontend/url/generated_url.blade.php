<input class="form-control m-1" readonly type="text" value="{{$url->short_url}}" id="myInput">
<button class=" btn btn-info m-1" onclick="myFunction()">Copy</button>
<button id="{{$url->id}}" onclick="customizeFunction(this.id)" class="btn btn-warning m-1" >Customize URL</button>
