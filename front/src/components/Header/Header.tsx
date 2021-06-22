import * as React from 'react';
import './index.scss';
import { Link } from 'react-router-dom';

import { useHeader } from './useHeader';

const Header = () => {
  const { onSearch, onLogout, searchText } = useHeader();

  return (
    <div className="header container">
      <Link to="/" className="header__logo">
        <img src="/images/logo.svg" alt="logo" />
      </Link>
      <div className="header__search">
        <input
          type="text"
          placeholder="Пошук..."
          onChange={onSearch}
          value={searchText}
        />
        <img src="/images/search.svg" alt="search" />
      </div>
      <div className="header__control">
        <img src="/images/log-out.svg" alt="logout" onClick={onLogout} />
      </div>
    </div>
  );
};

export default Header;
