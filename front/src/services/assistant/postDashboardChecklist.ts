import { DEFAULT_URL } from '../Constants';
import requestApi from '../utils/requestApi';

type GetDashboardChecklistItem = {
  date_time: string;
  id: number;
  status: boolean;
  title: string;
}

export default async function postDashboardChecklist(
  token: string,
  process: string,
  contractId: string,
  bodyData: GetDashboardChecklistItem[],
) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/generator/${process}/checklist/${contractId}`,
    headers: { Authorization: `Bearer ${token}` },
    method: 'POST',
    bodyData,
  });

  if (!res?.success) throw new Error(`Проблема на боці сервера: ${res?.message}`);

  return res.data;
}
