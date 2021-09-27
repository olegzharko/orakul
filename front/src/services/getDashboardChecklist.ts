import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getDashboardChecklist(
  token: string,
  process: string,
  contractId: string,
) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/generator/${process}/checklist/${contractId}`,
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!res?.success) throw new Error(`Проблема на боці сервера: ${res?.message}`);

  return res.data;
}
