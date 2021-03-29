import * as React from 'react';
import './index.scss';
import { Link } from 'react-router-dom';

type Props = {
  title: string;
  children: React.ReactNode;
  link: string
  headerColor?: string;
}

const Card = ({ title, headerColor, children, link }: Props) => (
  <Link to={link} className="card">
    <div className="card__header" style={{ backgroundColor: headerColor || '' }}>
      <span style={{ color: headerColor ? 'white' : '' }}>{title}</span>
    </div>
    <div className="card__main">
      {children}
    </div>
  </Link>
);

export default Card;
