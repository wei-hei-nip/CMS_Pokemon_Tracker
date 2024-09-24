<header>
  <h1><?php echo $this->head['title']; ?></h1>
</header>

<table id='userTable'>
    
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>User Group</th>
        <th>Profile Visibility</th>
        <th>Change Profile Visibility</th>
    </tr>
    
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
            <form action="user-setting/<?php echo $user['user_id'] ?>/userVisibility" method="post">
                <select name="visibility">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            <button type="submit" name="updateUser">Assign</button></form>
        </td>
    </tr>

</table>

