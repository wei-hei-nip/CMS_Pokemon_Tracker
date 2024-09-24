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
        <th> Profile</th>
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
            <td>
                <?php if ($user['user_id'] != $_SESSION['user']['user_id']): ?>
                <a href=user-community/<?php echo $user['user_id'] ?>/profile> <?php echo $user['name'] ?>'s Pokedex</a>
                <?php endif; ?>
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