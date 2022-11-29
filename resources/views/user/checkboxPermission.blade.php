<table>
    <tbody>
        @foreach($subPerms as $valPerms)
        <tr>
            <td>
                <label class="checkbox">
                <input type="checkbox" name="Checkboxes4">
                <span></span>Default</label>
            </td>
            <td> {{ $valPerms->name }} </td>
            <td> {{ $valPerms->about }} </td>
        </tr>
        @endforeach
    </tbody>
</table>