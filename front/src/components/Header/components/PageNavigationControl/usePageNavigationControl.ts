import { useCallback } from 'react';
import { useHistory } from 'react-router-dom';

export const usePageNavigationControl = () => {
  const history = useHistory();

  const onLogoClick = useCallback(() => {
    history.push('/');
  }, []);

  const onReloadButtonClick = useCallback(() => {
    window.location.reload();
  }, []);

  const onBackButtonClick = useCallback(() => {
    if (history.location.pathname === '/') return;
    history.goBack();
  }, []);

  const onForwardButtonClick = useCallback(() => {
    history.goForward();
  }, []);

  return {
    onLogoClick,
    onBackButtonClick,
    onReloadButtonClick,
    onForwardButtonClick,
  };
};
