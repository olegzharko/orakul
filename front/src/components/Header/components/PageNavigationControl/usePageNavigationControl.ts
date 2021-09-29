import { useCallback } from 'react';
import { useHistory } from 'react-router-dom';

export const usePageNavigationControl = () => {
  const history = useHistory();

  const onLogoClick = useCallback(() => {
    history.push('/');
  }, [history]);

  const onReloadButtonClick = useCallback(() => {
    window.location.reload();
  }, []);

  const onBackButtonClick = useCallback(() => {
    if (history.location.pathname === '/') return;
    history.goBack();
  }, [history]);

  const onForwardButtonClick = useCallback(() => {
    history.goForward();
  }, [history]);

  return {
    onLogoClick,
    onBackButtonClick,
    onReloadButtonClick,
    onForwardButtonClick,
  };
};
