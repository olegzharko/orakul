import * as React from 'react';
import './index.scss';
import { useHeader } from './useHeader';

const Header = () => {
  const { onSearch, onLogout, searchText } = useHeader();

  return (
    <div className="header container">
      <div className="header__logo">
        <img src="/icons/logo.svg" alt="logo" />
      </div>
      <div className="header__search">
        <input
          type="text"
          placeholder="Пошук..."
          onChange={onSearch}
          value={searchText}
        />
        <img src="/icons/search.svg" alt="search" />
      </div>
      <div className="header__control">
        <img src="/icons/log-out.svg" alt="logout" onClick={onLogout} />
      </div>
    </div>
  );
};

export default Header;
