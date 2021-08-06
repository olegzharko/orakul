import React from 'react';
import { usePageNavigationControl } from './usePageNavigationControl';

const PageNavigationControl = () => {
  const {
    onLogoClick,
    onBackButtonClick,
    onReloadButtonClick,
    onForwardButtonClick,
  } = usePageNavigationControl();

  return (
    <div className="header__navigation">
      <img
        className="header__logo"
        src="/images/logo.svg"
        alt="logo"
        onClick={onLogoClick}
      />

      <img
        className="header__navButton"
        src="/images/arrow-left-nav.svg"
        alt="logo"
        onClick={onBackButtonClick}
      />

      <img
        className="header__navButton"
        src="/images/arrow-right-nav.svg"
        alt="logo"
        onClick={onForwardButtonClick}
      />

      <img
        className="header__navButton"
        src="/images/reload.svg"
        alt="logo"
        onClick={onReloadButtonClick}
      />
    </div>
  );
};

export default PageNavigationControl;
