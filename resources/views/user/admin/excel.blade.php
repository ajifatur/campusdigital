<table border="1">
	<tr>
		<td align="center" width="5" style="background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};"><strong>No.</strong></td>
		<td align="center" width="40" style="background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};"><strong>Nama User</strong></td>
		<td align="center" width="40" style="background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};"><strong>Email</strong></td>
		<td align="center" width="20" style="background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};"><strong>Nomor HP</strong></td>
		<td align="center" width="15" style="background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};"><strong>Role</strong></td>
		<td align="center" width="15" style="background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};"><strong>Status</strong></td>
	</tr>
	@foreach($user as $key=>$data)
	<tr>
		<td>{{ ($key+1) }}</td>
        <td>{{ $data->nama_user }}</td>
        <td>{{ $data->email }}</td>
        <td align="center">{{ $data->nomor_hp }}</td>
        <td align="center">{{ $data->nama_role }}</td>
        <td align="center">{{ $data->status == 1 ? 'Aktif' : 'Belum Aktif' }}</td>
	</tr>
	@endforeach
</table>