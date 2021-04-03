import * as React from 'react';
import './index.scss';
import { Link, useHistory } from 'react-router-dom';

type Props = {
  title: string;
  children: React.ReactNode;
  link: string
  onClick: (id: string | undefined) => void;
  id?: string;
}

const CardWithClose = ({ id, title, children, link, onClick }: Props) => {
  const handleClick = (e: any) => {
    e.preventDefault();
    onClick(id);
  };

  return (
    <Link to={link} className="card-close">
      <div className="card-close__header">
        <span>{title}</span>
        <button
          type="button"
          onClick={handleClick}
          className="card-close__button"
        >
          <img src="/icons/x.svg" alt="delete" />
        </button>
      </div>
      <div className="card-close__main">
        {children}
      </div>
    </Link>
  );
};

export default CardWithClose;
