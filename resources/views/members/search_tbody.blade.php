@if ($members->isEmpty())
<tr>
  <td class="text-center" colspan="8">検索結果はありません</td>
</tr>
@else
  @foreach ($members as $member)
<tr>
  <td><input type="checkbox" name="member_id[]" value="{{ $member->id }}"></td>
  <td><a href="{{ route('members.edit', $member->id) }}"><u>{{ $member->disp_id }}</u></a></td>
  <td>{{ config('const.member.status.' . $member->status ) }}</td>
  <td>{{ $member->lname }} {{ $member->fname }}</td>
  <td>{{ $member->company }}</td>
  <td>{{ $member->department }}</td>
  <td>{{ $member->email }}</td>
  <td>{{ $member->last_loggedin_at }}</td>
  <td>{{ $member->created_at }}</td>
</tr>
  @endforeach
@endif
