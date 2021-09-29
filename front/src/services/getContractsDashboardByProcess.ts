import { DEFAULT_URL } from './Constants';
import requestApi from './utils/requestApi';

export default async function getContractsDashboardByProcess(
  token: string,
  process: string,
  cardId: string,
) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/generator/${process}/main/${cardId}`,
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!res?.success) throw new Error(`Проблема на боці сервера: ${res?.message}`);

  return res.data;
}
