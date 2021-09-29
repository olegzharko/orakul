import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

type BodyData = {
  page: number;
  start_date?: string | null;
  final_date?: string | null;
  contract_type_id?: string;
  dev_group_id?: string;
  dev_representative_id?: string;
}

export default async function getArchiveTableData(
  token: string,
  notaryId: number,
  bodyData: BodyData,
) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/archive/data/${notaryId}?page=${bodyData.page}`,
    headers: { Authorization: `Bearer ${token}` },
    method: 'POST',
    bodyData,
  });

  if (!res.success) throw new Error(res.message);

  return res.data;
}
