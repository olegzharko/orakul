import { useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import { useHistory, useParams } from 'react-router';

import { CheckListItem } from '../../../../../../components/CheckList/CheckList';
import getDashboardChecklist from '../../../../../../services/assistant/getDashboardChecklist';
import postDashboardChecklist from '../../../../../../services/assistant/postDashboardChecklist';
import { State } from '../../../../../../store/types';

export const useContractChecklist = () => {
  const history = useHistory();

  const { token } = useSelector((state: State) => state.main.user);
  const { process, contractId } = useParams<{process: string, contractId: string}>();

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [checkList, setCheckList] = useState<CheckListItem[]>([]);

  // Memo
  const formattedCheckList = useMemo(() => checkList.map((check, index) => ({
    ...check,
    onChange: () => {
      const currentStatus = checkList[index].status;
      checkList[index].status = !currentStatus;
      setCheckList([...checkList]);
    },
  })), [checkList]);

  // Callbacks
  const onCancel = useCallback(() => {
    history.goBack();
  }, [history]);

  const onSave = useCallback(async () => {
    if (!token) return;

    await postDashboardChecklist(token, process, contractId, checkList);
    history.goBack();
  }, [checkList, contractId, history, process, token]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;

      try {
        const res = await getDashboardChecklist(token, process, contractId);
        setCheckList(res);
      } catch (e: any) {
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [contractId, process, token]);

  return {
    isLoading,
    formattedCheckList,
    onCancel,
    onSave,
  };
};
