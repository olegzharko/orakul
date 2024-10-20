import * as React from 'react';
import './index.scss';

import { useHeader } from './useHeader';
import UserSelect from './components/UserSelect';
import PageNavigationControl from './components/PageNavigationControl';

const Header = () => {
  const {
    searchText,
    isNotCompanyUser,
    onSearch,
    onLogout,
  } = useHeader();

  return (
    <div className="header container">
      <PageNavigationControl />
      {!isNotCompanyUser && (
        <div className="header__search">
          <input
            type="text"
            placeholder="Пошук..."
            onChange={onSearch}
            value={searchText}
          />
          <img src="/images/search.svg" alt="search" />
        </div>
      )}

      <div className="header__control">
        {!isNotCompanyUser && (
          <UserSelect />
        )}

        <img src="/images/log-out.svg" alt="logout" onClick={onLogout} />
      </div>
    </div>
  );
};

export default Header;
