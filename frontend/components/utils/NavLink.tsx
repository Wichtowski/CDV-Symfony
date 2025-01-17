
import React from 'react';
import Link from 'next/link';

interface NavLinkProps {
    href: string;
    label?: string;
    queryParam?: string;
    styles?: string;
}

const NavLink: React.FC<NavLinkProps> = ({ href = '/', label = 'Go Back', styles = '', queryParam = '' }) => {
    return (
        <Link
            href={{ pathname: href, query: queryParam ? { param: queryParam } : {} }}
            className={styles}
        >
            {label}
        </Link>
    );
};

export default NavLink;
