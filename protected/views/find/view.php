<div style="margin-top:100px">
	<form method="POST">
		<label>Search</label>
		<select name="find[searchType]">
			<option value="key">Keyword</option>
			<option value="tag">Tag</option>
			<option value="cat">Category</option>
		</select>
		<input type="search" name="find[searchKey]">
		<input type="submit" name="find[search]" value="Search" class="btn btn-danger">
	</form>	
</div>
<div id="searchResult">
</div>