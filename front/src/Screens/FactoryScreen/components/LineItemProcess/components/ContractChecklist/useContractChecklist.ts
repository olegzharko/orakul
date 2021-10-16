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
  const { processType, contractId } = useParams<{processType: string, contractId: string}>();

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

    await postDashboardChecklist(token, processType, contractId, checkList);
    history.goBack();
  }, [checkList, contractId, history, processType, token]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;

      try {
        const res = await getDashboardChecklist(token, processType, contractId);
        setCheckList(res);
      } catch (e: any) {
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [contractId, processType, token]);

  return {
    isLoading,
    formattedCheckList,
    onCancel,
    onSave,
  };
};
