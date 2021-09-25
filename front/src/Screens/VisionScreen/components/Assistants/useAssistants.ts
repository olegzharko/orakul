import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';

import getAssistantsByRooms from '../../../../services/vision/assistants/getAssistantsByRooms';
import { State } from '../../../../store/types';
import { AssistantsWorkspace } from './types';

export const useAssistants = () => {
  const { token } = useSelector((state: State) => state.main.user);

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [workspace, setWorkspace] = useState<AssistantsWorkspace[]>();

  useEffect(() => {
    (async () => {
      if (!token) return;

      try {
        const res = await getAssistantsByRooms(token);
        setWorkspace(res);
      } catch (e: any) {
        alert(e.message);
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [token]);

  return {
    isLoading,
    workspace,
  };
};
