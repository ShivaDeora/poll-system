<form method="POST" action="/admin/polls">
    @csrf

    <label>Question</label>
    <input type="text" name="question" required>

    <div id="options">
        <input type="text" name="options[]" placeholder="Option 1" required>
        <input type="text" name="options[]" placeholder="Option 2" required>
    </div>

    <button type="button" onclick="addOption()">Add Option</button>

    <button type="submit">Create Poll</button>
</form>

<script>
function addOption() {
    let div = document.getElementById('options');
    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'New option';
    div.appendChild(input);
}
</script>