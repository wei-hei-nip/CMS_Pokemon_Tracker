<header>
    <h1><?php echo $this->head['title']; ?></h1>
</header>

<input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by name...">

<table id='userTable'>
    
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>User Group</th>
        <th>Profile Visibility</th>
        <th>Remove User</th>
        <th>Manage User Group</th>
    </tr>
    
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['user_group']; ?></td> 
            <td>
                <?php if ($user['visibility']): ?>Public
                <?php else: ?>Private
                    <?php endif; ?>
            </td>
            <td><?php if ($user['user_id'] != $_SESSION['user']['user_id'] and $user['user_id'] != 1){
                echo '<a href="users/'. $user['user_id']. '/remove'. '">remove</a>';
            }?></td>
            
            <td>
            <?php if ($user['user_id'] != $_SESSION['user']['user_id'] and $user['user_id'] != 1){
                echo'
                <form action="users/'. $user['user_id']. '/assignUser" method="post">
                    <select name="assignUser">
                        <option value="member">Member</option>
                        <option value="admin">Admin</option>
                    </select>
                <button type="submit" name="updateUser">Assign</button></form>
                ';
            }?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


<script>
    function searchTable() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("userTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those that don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; 
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>