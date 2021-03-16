import * as React from 'react';
import './index.scss';
import { useHeader } from './useHeader';

const Header = () => {
  const { onSearch, searchText } = useHeader();

  return (
    <div className="header">
      <div className="header__search">
        <input
          type="text"
          placeholder="Пошук..."
          onChange={onSearch}
          value={searchText}
        />
        <img src="/icons/search.svg" alt="search" />
      </div>
    </div>
  );
};

export default Header;
